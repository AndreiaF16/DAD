<template>
    <div>
        <h1>Statistics</h1>

        <div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Total Users</th>
                        <th>Total Administrators</th>
                        <th>Total Operators</th>
                        <th>Total Platform Users</th>
                        <th>Total Movements</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{totalUsers}}</td>
                        <td>{{totalAdmins}}</td>
                        <td>{{totalOperators}}</td>
                        <td>{{totalPlatformUsers}}</td>
                        <td>{{totalMovements}}</td>
                        
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
export default {
    data: function () {
			return {
                totalUsers: "",
                totalAdmins: "",
                totalOperators: "",
                totalPlatformUsers: "",
                totalMovements: "",
               
			}
		},
        methods: {
            getTotalUsers(){
                axios.get("api/totalUsers").then(({ data }) => (this.totalUsers = data));
            },
            getTotalAdmins(){
                axios.get("api/totalAdmins").then(({ data }) => (this.totalAdmins = data));
            },
            getTotalOperators(){
                axios.get("api/totalOperators").then(({ data }) => (this.totalOperators = data));
            },
            getTotalPlatformUsers(){
                axios.get("api/totalPlatformUsers").then(({ data }) => (this.totalPlatformUsers = data));
            },
            getTotalMovements(){
                axios.get("api/totalMovements").then(({ data }) => (this.totalMovements = data));
            },
            
            
        },
        created(){
            this.getTotalUsers();
            this.getTotalAdmins();
            this.getTotalOperators();
            this.getTotalPlatformUsers();  
            this.getTotalMovements();
           
        }
    }
</script>