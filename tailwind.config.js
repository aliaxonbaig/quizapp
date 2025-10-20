import preset from './vendor/filament/support/tailwind.config.preset'
import colors from 'tailwindcss/colors'

export default {
    presets: [preset],
    content: [
        './app/Filament/**/*.php',
        './resources/views/filament/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
        './resources/views/Livewire/**/*.blade.php',
    ],
    theme: {
        extend: {
            colors: {
                primary: {
                    50: '#e6f7f0',
                    100: '#ccefdf',
                    200: '#99dfbf',
                    300: '#66cf9f',
                    400: '#33bf7f',
                    500: '#007241', // Main school green
                    600: '#005b34',
                    700: '#004427',
                    800: '#002e1a',
                    900: '#00170d',
                },
                secondary: {
                    50: '#fef9eb',
                    100: '#fef3d6',
                    200: '#fde7ad',
                    300: '#fbdb84',
                    400: '#facf5b',
                    500: '#f9c432', // Main school yellow
                    600: '#c79d28',
                    700: '#95761e',
                    800: '#644e14',
                    900: '#32270a',
                },
                success: colors.green,
                danger: colors.red,
                warning: colors.amber,
                info: colors.blue,
            },
        },
    },
}
