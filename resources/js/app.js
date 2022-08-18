import './bootstrap';
import Alpine from 'alpinejs';

import alert from './alert';
import reply from './reply';
import favoriteButton from './favoriteButton';

Alpine.data('alert', alert);
Alpine.data('replyComponent', reply);
Alpine.data('favoriteButton', favoriteButton);

window.Alpine = Alpine;

Alpine.start();
