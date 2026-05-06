import { describe, it, expect, beforeEach } from 'vitest'
import { setActivePinia, createPinia } from 'pinia'
import { useAuthStore } from '../stores/authStore'
import router from '../router/index.js'

describe('router', () => {

  beforeEach(() => {
    setActivePinia(createPinia())
 })

  it('redirects to login if not authenticated', async () => {
    await router.push('/profil')
    await router.isReady()
    expect(router.currentRoute.value.name).toBe('Se connecter')
}) 

  it('allows access to profil if authenticated', async () => {
    const store = useAuthStore()
    store.login('eyJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE3NDU5MzgxNDUsImV4cCI6OTk5OTk5OTk5OSwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoidGVzdHVzZXIifQ.fake-signature')
    await router.push('/profil')
    await router.isReady()
    expect(router.currentRoute.value.name).toBe('Profil')
})
  
  it ('redirects to profil if already logged in and tries to access login', async () => {
    const store = useAuthStore()
    store.login('eyJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE3NDU5MzgxNDUsImV4cCI6OTk5OTk5OTk5OSwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoidGVzdHVzZXIifQ.fake-signature')
    await router.push('/login')
    await router.isReady()
    expect(router.currentRoute.value.name).toBe('Profil')
  })  
})