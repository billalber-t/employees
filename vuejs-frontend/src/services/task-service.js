import axios from 'axios';

const API_URL = process.env.VUE_API_URL;

const headers = {
    'Accept': 'application/json',
    'Content-Type': 'application/json'
}

class taskService{

    getAllTasks(){
        return axios.get(API_URL + '/tasks', { headers : headers});
    }
    
}
export default new taskService;