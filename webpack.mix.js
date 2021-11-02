const mix = require('laravel-mix');
const { webpackConfig } = require('laravel-mix');
const ImageminPlugin = require('imagemin-webpack-plugin').default;

mix.webpackConfig({
  module: {
    rules: [
      {
        test: /\.pug$/,
        oneOf: [
          {
            resourceQuery: /^\?vue/,
            use: ['pug-plain-loader']
          },
          {
            use: ['raw-loader', 'pug-plain-loader']
          }
        ]
      }
    ]
  },
  plugins: [
    new ImageminPlugin({
      //            disable: process.env.NODE_ENV !== 'production', // Disable during development
      pngquant: {
        quality: '95-100',
      },
      test: /\.(jpe?g|png|gif|svg)$/i,
    }),
  ],
  resolve: {
    alias: {
      '@': path.resolve(
        __dirname, 'resources'
      )
    }
  },
});

mix
  .js('themes/erso/src/js/main.js', 'js')
  .js('themes/erso/src/js/vue-app/app.js', 'js')
  .sass('themes/erso/src/scss/app.sass', 'css')
  // .copy('resources/img', 'img', false).sourceMaps()
  .setPublicPath('themes/erso/assets/')