import { describe, it, expect, vi } from 'vitest'
import { bibliothequeService } from '../services/bibliothequeService'
import api from '../services/api'

vi.mock('../services/api')

describe ('bibliothequeService', () => {

 it('searchBooks', async () => {
    api.get.mockResolvedValue({ data: { "book_isbn": "9781781101032",
                    "book_name": "Harry Potter test",
                    "book_publication": "2015-12-08",
                    "book_page": 362,
                    "book_description": "Test description",
                    "book_language": "fr",
                    "book_cover": null,
                    "reading_status": "a_lire" } })
    
    await bibliothequeService.searchBooks('harry')

    expect(api.get).toHaveBeenCalledWith('/books/search?q=harry')
    })

 it('addBook', async () => {
    api.post.mockResolvedValue({ data: { "book_isbn": "9781781101032",
                    "book_name": "Harry Potter test",
                    "book_publication": "2015-12-08",
                    "book_page": 362,
                    "book_description": "Test description",
                    "book_language": "fr",
                    "book_cover": null,
                    "reading_status": "a_lire" } })

    await bibliothequeService.addBook({ book_isbn: '9781781101032', reading_status: 'a_lire' })

    expect(api.post).toHaveBeenCalledWith('/books/add', expect.any(Object))
    })
       
 it('getLibraryURL', async () => {
    api.get.mockResolvedValue({ data: [] })
    
    await bibliothequeService.getLibrary()

    expect(api.get).toHaveBeenCalledWith('/books/library')
    })

 it('updateReading', async () => {
    api.patch.mockResolvedValue({ data: [] })
    
    await bibliothequeService.updateReading(1, 'en_cours')

    expect(api.patch).toHaveBeenCalledWith('/library/1', { reading_status: 'en_cours' })
    })

 it('deleteReading', async () => {
    api.delete.mockResolvedValue({ data: [] })
    
    await bibliothequeService.deleteReading(1)

    expect(api.delete).toHaveBeenCalledWith('/library/1')
    })

})