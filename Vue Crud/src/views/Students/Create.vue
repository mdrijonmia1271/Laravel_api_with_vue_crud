<template>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h4>Add Students</h4>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="">Name</label>
                    <input type="text" v-model="model.users.name" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="">email</label>
                    <input type="email" v-model="model.users.email" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="">password</label>
                    <input type="password" v-model="model.users.password" class="form-control" />
                </div>
                <div class="mb-3">
                    <button type="button" @click="saveStudent()" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
export default {

    name: 'studentCreate',
    data() {
        return {
            // errorlist: '';
            model: {
                users: {
                    name: '',
                    email: '',
                    password: '',
                }
            }
        }
    },
    methods: {
        saveStudent() {
            axios.post('http://127.0.0.1:8000/api/create', this.model.users).then(res => {
                console.log(res.data)
                alert(res.data.message);
                this.model.users = {
                    name: '',
                    email: '',
                    password: '',
                }
            });
        }
    }
}
</script>