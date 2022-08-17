import './bootstrap';
import Alpine from 'alpinejs';

import alert from './alert';

Alpine.data('alert', alert);

window.Alpine = Alpine;

Alpine.start();
