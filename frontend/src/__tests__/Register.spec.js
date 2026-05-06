import { describe, it, expect, beforeEach, vi } from 'vitest'
import { setActivePinia, createPinia } from 'pinia'
import Register from '../views/auth/Register.vue'
import { mount } from '@vue/test-utils'
import { authService } from '../services/authService'


// simulates router and API
vi.mock('vue-router', () => ({
    useRouter: () => ({ push: vi.fn() })
}))

vi.mock('../services/authService', () => ({
    authService: { register: vi.fn() }
}))

describe('Register', () => {

  beforeEach(() => {
    setActivePinia(createPinia())
 })

 it('displays the registration form', () => {
    const wrapper = mount(Register)
    expect(wrapper.find('form').exists()).toBe(true)
  });

 it('form with differents password', async () => {
    const wrapper = mount(Register)
    await wrapper.find('#password').setValue('password123')
    await wrapper.find('#confirmPassword').setValue('autrechose')
    await wrapper.find('form').trigger('submit')
    expect(wrapper.find('.error-message').exists()).toBe(true)
 })

 it ('form with differents email', async () => {
    const wrapper = mount(Register)
    await wrapper.find('#email').setValue('test@gmail.com')
    await wrapper.find('#confirmEmail').setValue('test1@gmail.com')
    await wrapper.find('form').trigger('submit')
    expect(wrapper.find('.error-message').exists()).toBe(true) 
 })

 it ('Register successful',async () => {
   const wrapper = mount(Register)
   await wrapper.find('#identifiant').setValue('testtest')
    await wrapper.find('#password').setValue('password123')
    await wrapper.find('#confirmPassword').setValue('password123')
    await wrapper.find('#email').setValue('test@gmail.com')
    await wrapper.find('#confirmEmail').setValue('test@gmail.com')
    await wrapper.find('form').trigger('submit')
    expect(authService.register).toHaveBeenCalledWith('testtest', 'test@gmail.com', 'password123')
   })

 
 })
