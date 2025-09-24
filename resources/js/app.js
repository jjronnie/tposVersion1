import './bootstrap'
import './custom'

import Alpine from 'alpinejs'
import collapse from '@alpinejs/collapse'
import { createIcons, icons } from 'lucide'

import './custom.js';


Alpine.plugin(collapse)
window.Alpine = Alpine
Alpine.start()

document.addEventListener('DOMContentLoaded', () => {
  createIcons({ icons })
})









