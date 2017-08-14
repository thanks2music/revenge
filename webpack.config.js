'use strict';

const path = require('path');
const webpack = require('webpack');

module.exports = {
  entry: {
    app: path.resolve(__dirname, 'javascripts/main.js'),
  },
  output: {
    filename: '[name].js',
    path: path.resolve(__dirname, 'dist/scripts'),
  },
  // ローダーの設定
  module: {
    loaders: [{
      test: /\.js$/,
      exclude: /node_modules/,
      loader: 'babel-loader',
      query: {
        presets: ['es2015']
      }
    }],
  },
  // プラグインの設定
  plugins: [
    new webpack.optimize.CommonsChunkPlugin({
      name: ['app']
    }),
  ]
}
