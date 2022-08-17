import './bootstrap';
import Alpine from 'alpinejs';

import alert from './alert';
import reply from './reply';

Alpine.data('alert', alert);
Alpine.data('replyComponent', reply);

window.Alpine = Alpine;

Alpine.start();
