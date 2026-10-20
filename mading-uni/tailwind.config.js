/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './app/**/*.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['"Plus Jakarta Sans"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
            },
            colors: {
                // Brand platform (Mading Indonesia)
                brand: {
                    50: '#FDF2FC',
                    100: '#FCE7F9',
                    200: '#F9CEF3',
                    300: '#F5A5E8',
                    400: '#ED96D7',
                    500: '#C654C3',
                    600: '#A82BA8',
                    700: '#8E1EA2',
                    800: '#721A82',
                    900: '#5C1568',
                },
                // Neutral
                ink: {
                    DEFAULT: '#241A26',
                    muted: '#6F6571',
                    soft: '#A69EAA',
                },
                surface: {
                    DEFAULT: '#FFFFFF',
                    muted: '#FAF8FA',
                    border: '#E9E2EA',
                },
                // Status
                success: '#22C55E',
                warning: '#F59E0B',
                danger: '#EF4444',
                info: '#3B82F6',
            },
            borderRadius: {
                DEFAULT: '8px',
                md: '10px',
                lg: '12px',
                xl: '16px',
                '2xl': '20px',
                '3xl': '24px',
            },
            boxShadow: {
                card: '0 1px 3px 0 rgba(36, 26, 38, 0.05), 0 1px 2px -1px rgba(36, 26, 38, 0.05)',
                'card-hover': '0 10px 25px -5px rgba(142, 30, 162, 0.15), 0 8px 10px -6px rgba(142, 30, 162, 0.1)',
                dropdown: '0 4px 12px rgba(36, 26, 38, 0.08)',
            },
            backgroundImage: {
                'brand-gradient': 'linear-gradient(135deg, #8E1EA2 0%, #C654C3 50%, #ED96D7 100%)',
                'brand-gradient-soft': 'linear-gradient(135deg, #FFC0DE 0%, #ED96D7 50%, #C654C3 100%)',
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
};