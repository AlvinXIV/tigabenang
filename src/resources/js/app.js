import Alpine from 'alpinejs';
import Chart from 'chart.js/auto';
import '@google/model-viewer';

// Expose Alpine & Chart to window for inline scripts and blade views
window.Alpine = Alpine;
window.Chart = Chart;

// Start Alpine
Alpine.start();
