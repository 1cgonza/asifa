const Uglify = require('webpack').optimize.UglifyJsPlugin;

module.exports = {
  debug: true,
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
        exclude: /node_modules/,
        loader: 'babel',
        query: {
          presets: ['es2015']
        }
      },
      {
        test: /\.json$/,
        loader: 'json'
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
