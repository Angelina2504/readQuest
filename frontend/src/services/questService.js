import api from "./api";

export const questService = {
    async getQuest(){
        try { const response = await api.get('/quests')
            return response.data
        } catch (error) {
            console.error('Erreur lors de la récupération des quêtes :', error.response?.data || error.message);
            throw error; 
        }
    },

    async joinQuests(id){
        try { const response = await api.post(`/quests/${id}/join`)
            return response.data
        } catch (error) {
            console.error('Erreur l\'ajout de quête :', error.response?.data || error.message);
            throw error; 
        }
    },

    async getMyQuests(){
        try { const response = await api.get(`/quests/my`)
            return response.data
        } catch (error) {
            console.error('Erreur la récupération des quêtes utilisateurs :', error.response?.data || error.message);
            throw error; 
        }
    },

    async leaveQuests(id){
        try { const response = await api.delete(`/quests/${id}/leave`)
            return response.data
        } catch (error) {
            console.error('Erreur à la suppression d\'une quête:', error.response?.data || error.message);
            throw error; 
        }
    }, 

}