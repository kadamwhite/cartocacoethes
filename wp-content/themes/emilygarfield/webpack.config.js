const path = require('path');
const ExtractTextPlugin = require('extract-text-webpack-plugin');

module.exports = {
  devtool: 'source-map',
  context: __dirname,
  entry: {
    style: './style/index.styl'
  },
  output: {
    path: path.join(__dirname, 'build'),
    filename: '[name].js'
  },
  module: {
    loaders: [
      {
        test: /\.(ico|jpg|jpeg|png|gif|eot|otf|webp|svg|ttf|woff|woff2|svg)(\?.*)?$/,
        loader: 'raw-loader'
      },
      {
        test: /\.styl$/,
        loader: ExtractTextPlugin.extract('style-loader', 'css-loader?sourceMap!stylus-loader')
      }
    ]
  },
  plugins: [
    new ExtractTextPlugin('[name].css')
  ]
};
