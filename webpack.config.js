const Uglify = require('webpack').optimize.UglifyJsPlugin;

module.exports = {
  context: __dirname + '/dev/js',
  devtool: 'source-map',
  entry: {
    'scripts': './main.js',
    'admin': './admin.js'
  },
  output: {
    filename: '[name].min.js',
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
