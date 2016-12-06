const Uglify = require('webpack').optimize.UglifyJsPlugin;

module.exports = {
  context: __dirname + '/dev/js',
  devtool: 'source-map',
  entry: './main.js',
  output: {
    filename: 'scripts.min.js',
    path: __dirname + '/js'
  },
  module: {
    loaders: [
      {
        test: /\.js$/,
        exclude: /(node_modules)/,
        loader: 'babel-loader'
      }
    ],
  },
  plugins: [
    new Uglify({
      compress: {warnings: false}
    })
  ],
  resolve: {
    alias: {
      'masonry': 'masonry-layout',
      'isotope': 'isotope-layout'
    }
  }
};