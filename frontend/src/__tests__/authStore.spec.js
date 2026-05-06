import { describe, it, expect, beforeEach } from 'vitest'
import { setActivePinia, createPinia } from 'pinia'
import { useAuthStore } from '../stores/authStore'

describe('authStore', () => {

  beforeEach(() => {
    setActivePinia(createPinia())
 })

  it('login() met isAuthenticated à true', () => {
    const store = useAuthStore()
    const token = 'eyJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE3NDU5MzgxNDUsImV4cCI6OTk5OTk5OTk5OSwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoidGVzdHVzZXIifQ.fake-signature'
    store.login(token)
    expect(store.isAuthenticated).toBe(true)
  })

  it('login() save token in localStorage', () => {
    const store = useAuthStore()
    const token = 'eyJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE3NDU5MzgxNDUsImV4cCI6OTk5OTk5OTk5OSwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoidGVzdHVzZXIifQ.fake-signature'
    store.login(token)
    expect(localStorage.getItem('token')).toBe(token)
  })

  it('logout() pass isAuthenticated to false', () => {
    const store = useAuthStore()
    const token = 'eyJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE3NDU5MzgxNDUsImV4cCI6OTk5OTk5OTk5OSwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoidGVzdHVzZXIifQ.fake-signature'
    store.login(token)
    store.logout()
    expect(store.isAuthenticated).toBe(false) 
  })

  it('inithAuth() restores the session from localStorage ', () => {
    const store = useAuthStore()
    const token = 'eyJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE3NDU5MzgxNDUsImV4cCI6OTk5OTk5OTk5OSwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoidGVzdHVzZXIifQ.fake-signature'
    localStorage.setItem('token', token)
    store.initAuth()
    expect(store.isAuthenticated).toBe(true)
  })

})
