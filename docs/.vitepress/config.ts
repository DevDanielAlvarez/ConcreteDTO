import { defineConfig } from 'vitepress';

export default defineConfig({
    title: 'ConcreteDTO',
    description: 'A simple and explicit PHP DTO library',
    base: '/ConcreteDTO/',
    themeConfig: {
        nav: [
            { text: 'GitHub', link: 'https://github.com/DevDanielAlvarez/ConcreteDTO' }
        ],
        sidebar: [
            {
                text: 'Getting Started',
                items: [
                    { text: 'Overview', link: '/getting-started' }
                ]
            },
            {
                text: 'Import & Export',
                items: [
                    { text: 'Importing Data', link: '/import' },
                    { text: 'Exporting Data', link: '/export' }
                ]
            },
            {
                text: 'Immutability',
                items: [
                    { text: 'Immutable Workflows', link: '/immutability' }
                ]
            }
        ]
    }
});
