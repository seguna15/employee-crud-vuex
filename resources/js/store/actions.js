import Vue from 'vue';
import axios  from 'axios';

let loader = null;

function displayLoader(loadingText = "Loading..."){
    loader = Vue.prototype.$loading({
        lock:true,
        text: loadingText,
        spinner: 'el-icon-loading',
        background: 'rgba(255,255,255,0.85)',
    });
}

function removeLoader(){
    loader.close();
}

export const saveEmployee = ({commit}, payload) => {

    displayLoader();

    axios.post(`/save-employee`, payload).then(res => {
        Vue.prototype.$notify({
            title: 'Success',
            message: 'Employee added successfully',
            type: 'success',
        });
        
        removeLoader();

        setTimeout(() => {
            window.location.href = '/employees'
        }, 2000)
    });
}

export const getEmployeesData = ({ commit }, payload) => {
    axios.post(`/get-employee-data`, payload).then(response => {
        commit('setTableData', response.data);
    });
}

export const updateEmployee = ({commit}, payload) => {

    displayLoader('Update Employee');

    axios.put(`/update-employee/${payload.id}`, payload.form).then(res => {
        Vue.prototype.$notify({
            title: 'Success',
            message: 'Employee updated successfully',
            type: 'success',
        });
        
        removeLoader();

        setTimeout(() => {
            window.location.href = '/employees'
        }, 2000)
    });
}



export const deleteEmployee = ({commit}, payload) => {

    displayLoader('Deleting Employee');
    
    axios.delete(`/delete-employee/${payload.id}`).then(res => {
        Vue.prototype.$notify({
            title: 'Success',
            message: res.data.message,
            type: 'success',
        });
        
        removeLoader();
    });

}