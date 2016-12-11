const path = require('path');
const autoprefixer = require('autoprefixer');
const ExtractTextPlugin = require('extract-text-webpack-plugin');

module.exports = {
  devtool: 'source-map',
  context: __dirname,
  entry: {
    theme: './js/theme.js'
  },
  output: {
    path: path.join(__dirname, 'build'),
    filename: '[name].js'
  },
  postcss: [
    autoprefixer({ browsers: ['last 2 versions', '> 1%'] })
  ],
  externals: {
    ehgScreenReaderText: 'ehgScreenReaderText',
    jquery: 'jQuery'
  },
  module: {
    loaders: [
      {
        test: /\.(ico|jpg|jpeg|png|gif|eot|otf|webp|svg|ttf|woff|woff2|svg)(\?.*)?$/,
        loader: 'raw-loader'
      },
      {
        test: /\.styl$/,
        loader: ExtractTextPlugin.extract('style-loader', 'css-loader?sourceMap!postcss-loader?sourceMap=inline!stylus-loader?sourceMap=inline')
      }
    ]
  },
  plugins: [
    new ExtractTextPlugin('style.css')
  ]
};
