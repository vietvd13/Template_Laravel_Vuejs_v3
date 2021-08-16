const path = require('path');
const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;
const ChunkRenamePlugin = require('webpack-chunk-rename-plugin');

const rawArgv = process.argv.slice(2);
const report = rawArgv.includes('--report');
const plugins = [new ChunkRenamePlugin({ initialChunksWithEntry: true, '/js/app': 'js/app.js', '/js/vendor': 'js/vendor.js' })];

if (report) {
  plugins.push(new BundleAnalyzerPlugin({
    openAnalyzer: true,
  }));
}

module.exports = {
  resolve: {
    extensions: ['.js', '.vue', '.json'],
    alias: {
      vue$: 'vue/dist/vue.esm.js',
      '@': path.join(__dirname, '/resources/js'),
    },
  },
  plugins: plugins,
  output: {
    filename: '[name].js',
    chunkFilename: 'js/[name].[chunkhash:6].js',
  },
};
