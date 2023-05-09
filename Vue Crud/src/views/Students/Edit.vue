<template>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h4>Add Students</h4>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="">Name</label>
                    <input type="text" v-model="model.users.name" class="form-control"  />
                </div>
                <div class="mb-3">
                    <label for="">email</label>
                    <input type="email" v-model="model.users.email" class="form-control"  />
                </div>
                <div class="mb-3">
                    <button type="button" @click="updateStudent()" class="btn btn-primary">Update</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    name: 'studentEdit',
    data() {
        return {
            studentId: '',
            errorlist: '',
            model: {
                users: {
                    name: '',
                    email: '',
                }
            }
        }
    },
    mounted(){
        // console.log(this.$route.params.id);
        this.studentId = this.$route.params.id;
        this.getStudentData(this.$route.params.id);
    },
    methods: {
        getStudentData(studentId){
            axios.get(`http://127.0.0.1:8000/api/index/${studentId}`).then(res => {
                console.log(res.data.users);
                this.model.users = res.data.users
            });
        },
        updateStudent() {
            axios.put(`http://127.0.0.1:8000/api/edit/${this.studentId}`, this.model.users).then(res => {
                console.log(res.data)
                alert(res.data.message);
                this.errorlist = '';
            })
                .catch(function (error) {
                if (error.response) {
                    if(error.response.status == 422){
                        var errorlist = error.response.data.errors;
                    }
                    // console.log(error.response.data);
                    // console.log(error.response.status);
                    // console.log(error.response.headers);
                } else if (error.request) {
                    console.log(error.request);
                } else {
                    console.log('Error', error.message);
                }
            });
    }
}
    }
</script>