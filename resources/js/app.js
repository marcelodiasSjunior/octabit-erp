import './bootstrap';
import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';
import Sortable from 'sortablejs';
import ApexCharts from 'apexcharts';

window.Alpine = Alpine;
window.Sortable = Sortable;
window.ApexCharts = ApexCharts;

Alpine.plugin(collapse);
Alpine.start();
