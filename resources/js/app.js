import './bootstrap';
import { renderPrestasiChart } from './prestasi';
import 'flowbite';

import Alpine from 'alpinejs';
import html2canvas from 'html2canvas';
window.html2canvas = html2canvas;

window.Alpine = Alpine;
window.renderPrestasiChart = renderPrestasiChart;
Alpine.start();
