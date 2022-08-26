module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        'brand': '#00AFEF',
      },
      fontFamily:{
        inter: ['Inter'],
        CabinetGrotesk:['CabinetGrotesk-Variable'],
        poppins:['poppins'],
      },
      rotate: {
        '20': '20deg',
      },
      transitionDuration: {
        '3000': '3000ms',
      },
      width: {
        '650': '650px',
        '387': '387px',
        '264':'264px',
      },
      height: {
        '650': '650px',
        '606': '606px',
        '387': '387px',
        '350':'350px',
        '400':'400px',
        '368.99':'368.99px',
        '264':'264px',

      }

    },
  },
  plugins: [],
}
