Feature('Ynov Nantes');

Scenario('Test Ynov Nantes Recherche', async ({I}) => {
    I.amOnPage('https://www.ynov-nantes.com/');
    I.click('.search-cta a');
    I.fillField({ css: '.search-form-input .searchfield' }, 'Info');
    I.waitForElement('.search-preview-cursus .preview-title .tile-title', 2);
    let tile = locate('.search-preview-cursus .preview-title .tile-title').withText('Bachelor Informatique');
    I.seeElement(tile);
});
