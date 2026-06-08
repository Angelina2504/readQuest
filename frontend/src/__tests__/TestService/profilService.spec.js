import { describe, it, expect, vi } from 'vitest'
import { profilService } from '../../services/profilService'
import api from '../../services/api'

vi.mock('../../services/api')

describe ('profilService', () => {

    it('getProfil returns profile data', async () => {
    api.get.mockResolvedValue({ data: { alias: 'testuser', email: 'test@test.com', birthday: '1992-05-05', gender: 'Femme', avatar: null } })
    
    const result = await profilService.getProfil()
    
    expect(result.alias).toBe('testuser')
    })

    it('updateProfile sends birthday and gender successfully', async () => {
    api.patch.mockResolvedValue({ data: { birthday: '1992-05-05', gender: 'Femme', avatar: null } })

    const result = await profilService.updateProfile('1992-05-05', 'Femme')
    
    expect(result.birthday).toBe('1992-05-05')
    })

    it('uploadAvatar sends form data successfully', async () => {
    api.post.mockResolvedValue({ data: { message: 'Avatar update' } })

    const result = await profilService.uploadAvatar(new FormData())

    expect(result.message).toBe('Avatar update')
    })
})