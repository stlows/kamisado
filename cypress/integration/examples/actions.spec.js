/// <reference types="cypress" />

context('Actions', () => {

  it('setToken', () => {
    cy.visit('http://localhost:8090/kamisado/dist/#/online/game/1')
    cy.get('#setFakeTokenInput').type('test_0004')
    cy.get('#setFakeTokenButton').click()
    cy.get('#newLobbyButton').click()
    cy.get('#setFakeTokenInput').clear().type('test_0003')
    cy.get('#setFakeTokenButton').click()
    cy.get('.lobby a.joinGameLink').first().click()
    cy.wait(500)
    cy.get('#refreshLink').click()
    cy.get('#setFakeTokenInput').clear().type('test_0004')
    cy.get('#setFakeTokenButton').click()

    cy.get('.tower.white.blue').trigger('mousedown', { button: 0 })
    cy.wait(500)
    cy.get('#tile_2_4').trigger("mousemove").trigger("mouseup")

  })

})
