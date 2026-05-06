import { describe, it, expect, beforeEach, vi } from 'vitest'
import { setActivePinia, createPinia } from 'pinia'
import Login from '../views/auth/LoginAuth.vue'
import { mount } from '@vue/test-utils'
import { authService } from '../services/authService'
import { useAuthStore } from '@/stores/authStore'


// simulates router and API
vi.mock('vue-router', () => ({
    useRouter: () => ({ push: vi.fn() })
}))

vi.mock('../services/authService', () => ({
    authService: { login: vi.fn() }
}))

describe('Login', () => {

  beforeEach(() => {
    setActivePinia(createPinia())
 })

 it('Displays the login form', () => {
    const wrapper = mount(Login)
    expect(wrapper.find('form').exists()).toBe(true)
 })

 it('Login fails', async () => {
    const wrapper = mount(Login)
    authService.login.mockRejectedValueOnce(new Error())
    await wrapper.find('form').trigger('submit')
    expect(wrapper.find('.error-message').exists()).toBe(true)
})

 it('Login successful', async () => {
    const wrapper = mount(Login)
    const store = useAuthStore()
    authService.login.mockResolvedValueOnce({ token: 'eyJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE3NDU5MzgxNDUsImV4cCI6OTk5OTk5OTk5OSwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoidGVzdHVzZXIifQ.fake-signature' })
    await wrapper.find('form').trigger('submit')
    expect(store.isAuthenticated).toBe(true)
})

})