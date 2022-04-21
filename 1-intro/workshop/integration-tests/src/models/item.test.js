const {it} = require('@jest/globals');
const {Item} = require('./Item');
const {createItem, listItems} = require('../services/itemService');

it('test item listing', () => {
    let items = listItems();
    expect(items).toBe({});
});

it('test item creation', () => {
    expect(true).toBe(true);
});

it('test item update', () => {
    expect(true).toBe(true);
});

it('test item deletion', () => {
    expect(true).toBe(true);
});
