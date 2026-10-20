<?php

namespace App\Services;

use App\Enums\PostStatus;
use App\Enums\ReviewAction;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class PostWorkflowService
{
    public function __construct(
        protected ActivityLogger $logger
    ) {}

    /**
     * Submit post untuk approval.
     * DRAFT / REJECTED → PENDING
     */
    public function submit(Post $post, User $actor): Post
    {
        $this->ensureCanTransition($post, PostStatus::PENDING);

        return DB::transaction(function () use ($post, $actor) {
            $post->update([
                'status' => PostStatus::PENDING,
                'submitted_at' => now(),
            ]);

            $this->recordReview($post, $actor, ReviewAction::SUBMITTED);
            $this->logger->log('post.submitted', $post, [
                'title' => $post->title,
            ]);

            return $post->fresh();
        });
    }

    /**
     * Approve post.
     * PENDING → APPROVED
     */
    public function approve(Post $post, User $actor, ?string $note = null): Post
    {
        $this->ensureCanTransition($post, PostStatus::APPROVED);

        return DB::transaction(function () use ($post, $actor, $note) {
            $post->update([
                'status' => PostStatus::APPROVED,
                'reviewed_at' => now(),
                'reviewed_by' => $actor->id,
            ]);

            $this->recordReview($post, $actor, ReviewAction::APPROVED, $note);
            $this->logger->log('post.approved', $post, [
                'note' => $note,
            ]);

            return $post->fresh();
        });
    }

    /**
     * Reject post.
     * PENDING → REJECTED
     * Note WAJIB diisi.
     */
    public function reject(Post $post, User $actor, string $note): Post
    {
        if (empty(trim($note))) {
            throw new InvalidArgumentException('Catatan penolakan wajib diisi.');
        }

        $this->ensureCanTransition($post, PostStatus::REJECTED);

        return DB::transaction(function () use ($post, $actor, $note) {
            $post->update([
                'status' => PostStatus::REJECTED,
                'reviewed_at' => now(),
                'reviewed_by' => $actor->id,
            ]);

            $this->recordReview($post, $actor, ReviewAction::REJECTED, $note);
            $this->logger->log('post.rejected', $post, [
                'note' => $note,
            ]);

            return $post->fresh();
        });
    }

    /**
     * Publish post.
     * APPROVED → PUBLISHED
     */
    public function publish(Post $post, User $actor, ?string $note = null): Post
    {
        $this->ensureCanTransition($post, PostStatus::PUBLISHED);

        return DB::transaction(function () use ($post, $actor, $note) {
            $post->update([
                'status' => PostStatus::PUBLISHED,
                'published_at' => now(),
                'reviewed_by' => $actor->id,
            ]);

            $this->recordReview($post, $actor, ReviewAction::PUBLISHED, $note);
            $this->logger->log('post.published', $post, [
                'title' => $post->title,
                'university_id' => $post->university_id,
            ]);

            return $post->fresh();
        });
    }

    /**
     * Archive post.
     * Bisa dari DRAFT, APPROVED, PUBLISHED → ARCHIVED
     */
    public function archive(Post $post, User $actor, ?string $note = null): Post
    {
        $this->ensureCanTransition($post, PostStatus::ARCHIVED);

        return DB::transaction(function () use ($post, $actor, $note) {
            $post->update([
                'status' => PostStatus::ARCHIVED,
            ]);

            $this->recordReview($post, $actor, ReviewAction::ARCHIVED, $note);
            $this->logger->log('post.archived', $post, [
                'note' => $note,
            ]);

            return $post->fresh();
        });
    }

    /**
     * Balikin REJECTED ke DRAFT biar bisa diedit ulang.
     * REJECTED → DRAFT
     */
    public function revertToDraft(Post $post, User $actor): Post
    {
        $this->ensureCanTransition($post, PostStatus::DRAFT);

        return DB::transaction(function () use ($post, $actor) {
            $post->update([
                'status' => PostStatus::DRAFT,
            ]);

            $this->logger->log('post.reverted_to_draft', $post);

            return $post->fresh();
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Internal Helpers
    |--------------------------------------------------------------------------
    */

    protected function ensureCanTransition(Post $post, PostStatus $target): void
    {
        if (! $post->status->canTransitionTo($target)) {
            throw new InvalidArgumentException(
                "Transisi tidak valid: {$post->status->value} → {$target->value}"
            );
        }
    }

    protected function recordReview(Post $post, User $actor, ReviewAction $action, ?string $note = null): void
    {
        $post->reviews()->create([
            'actor_id' => $actor->id,
            'action' => $action,
            'note' => $note,
        ]);
    }
}