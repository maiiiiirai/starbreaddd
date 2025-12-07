import { icons } from '../data/data.js';

export function getProductIcon(name) {
    const lowerName = name.toLowerCase();
  
    for (const item of icons) {
        if (item.names.includes(lowerName)) {
            return item.icon;
        }
    }
    return '❓';
}