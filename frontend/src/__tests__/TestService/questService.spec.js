import { describe, it, expect, vi } from 'vitest'
import { questService } from '../../services/questService'
import api from '../../services/api'

vi.mock('../../services/api')

describe ('questService', () => {

    it('getQuest', async () => {
    api.get.mockResolvedValue({ data : [] })
    
    await questService.getQuest('')

    expect(api.get).toHaveBeenCalledWith('/quests')
    })

    it('joinQuests', async () => {
    api.post.mockResolvedValue({ data : [] })
    
    await questService.joinQuests(1)

    expect(api.post).toHaveBeenCalledWith(`/quests/1/join`)
    })

    it('getMyQuests', async () => {
    api.get.mockResolvedValue({ data : [] })
    
    await questService.getMyQuests('')

    expect(api.get).toHaveBeenCalledWith(`/quests/my`)
    })

    it('leaveQuests', async () => {
    api.delete.mockResolvedValue({ data : [] })
    
    await questService.leaveQuests(1)

    expect(api.delete).toHaveBeenCalledWith(`/quests/1/leave`)
    })

})