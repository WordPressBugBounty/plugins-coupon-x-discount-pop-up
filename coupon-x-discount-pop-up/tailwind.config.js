const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    // important: '.coupon-x-discount-pop-up',
    content: [
        './inc/*.php',
        './inc/**/*.php'
    ],

    theme: {
        extend: {
            fontFamily: {
                primary: ['Poppins','sans-serif', ...defaultTheme.fontFamily.sans],
            },

            colors: {
                'cx-gray-150'      : '#1E1E37',
                'cx-gray-100'      : '#F7F8FC',
                'cx-gray-50'       : '#eaeff2',
                'cx-primary'       : '#656BE8',
                'cx-primary-100'   : '#4b51ca',
                'cx-primary-50'    : '#8287ef',
                'cx-black'         : '#1E1E37',
                'cx-black-100'     : '#413972',
                'cx-green'         : '#00a65a',
                'cx-red'           : '#dd4b39'
            },

            backgroundImage: {
                'gradient-100': 'linear-gradient(93.92deg, #675cd3 7.55%, #d87abf 95.33%)',
            },

            dropShadow: {
                '3xl': '0px 9px 7px rgba(183, 141, 235, .4)',
                '4xl': '0px 12px 19px rgba(183, 141, 235, .4)',
                '5xl': '0px 28px 28px rgba(0, 0, 0, 0.25)',
                '6xl': '0px 0px 15px rgba(0, 0, 0, 0.1)',
            },
        }
    },
    plugins: [
        // This plugin allows you to create custom Tailwind groups.
        // e.g. if you use ['custom'], you could use it as follows:
        //      In the parent: group-custom
        //      In the child:  group-custom-hover:
        require('tailwindcss-labeled-groups')([
            'custom', '1', /* RENAME ME! */ 
        ])
        // ...
    ],

};

