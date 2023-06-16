import axios from 'axios';

// const API_URL = process.env.VUE_API_URL;
const API_URL = 'http://localhost/Employees/backend/public/api';

const headers = {
    'Accept': 'application/json',
    'Content-Type': 'application/json'
}

class taskService {

    getAllEmployees() {
        return axios.get(API_URL + '/employees', { headers: headers });
    }
    createEmployee(employee) {
        return axios.post(API_URL + '/employees', employee, { headers: headers });
    }
    updateEmployee(employee) {
        return axios.put(API_URL + '/employees/' + employee.id, employee, { headers: headers });
    }
    deleteEmployee(employee_id) {
        return axios.delete(API_URL + '/employees/' + employee_id, { headers: headers });
    }

}
export default new taskService;