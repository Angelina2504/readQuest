import { describe, it, expect, vi } from 'vitest'
import { mount, flushPromises } from '@vue/test-utils'
import ProfilInfos from '../components/profil/ProfilInfos.vue'
import { profilService } from '../services/profilService'

vi.mock('../services/profilService')

describe ('ProfilInfos.spec.js', () => {

it('displays profile data after loading', async () => {
    profilService.getProfil.mockResolvedValue({
        alias: 'testuser',
        email: 'test@test.com',
        birthday: '1992-05-05',
        gender: 'Femme',
        avatar: null
    })

    const wrapper = mount(ProfilInfos)
    await flushPromises()

    expect(wrapper.text()).toContain('testuser')
})

it('activates edit mode when modifier button is clicked', async () => {
    profilService.getProfil.mockResolvedValue({
        alias: 'testuser',
        email: 'test@test.com',
        birthday: '1992-05-05',
        gender: 'Femme',
        avatar: null
    })

    const wrapper = mount(ProfilInfos)
    await flushPromises()

    await wrapper.find('button.edit-button').trigger('click')

    expect(wrapper.find('button.edit-button').text()).toBe('Enregistrer')
})


})