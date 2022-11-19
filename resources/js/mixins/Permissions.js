export default {
    data() {
        return {
            _user_data: null
        }
    },
    methods: {
        getUserData() {
            if (this._user_data == null) {
                this._user_data = JSON.parse(document.head.querySelector(`meta[name="global_data"]`).content)
                    return this._user_data
            } else{
				return this._user_data;
			}
        },
       
        hasRole(model_has_roles) {
			if (_.isArray(model_has_roles)) {
				return model_has_roles.find(u => {
					return this.getUserData().roles.find(r => u == r.name)
				}) != undefined
			} else {
				return this.getUserData().roles.find(r => model_has_roles == r.name) != undefined
			}
		},
        
		hasPermissionTo(role_has_permissions) {
			if (_.isArray(role_has_permissions)) {
				return role_has_permissions.find(u => {
					return this.getUserData().permissions.find(r => u == r.name)
				}) != undefined
			} else {
				return this.getUserData().permissions.find(r => role_has_permissions == r.name) != undefined
			}
		}
	}
}