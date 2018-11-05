let vm = new Vue({
    el: "#menu",
    data: {
        menu: false,
        class_name: "fa-bars",
        header_class_names: "",
        mobile: false,
    },
    created: function () {
        if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) )
        {
            this.mobile = true;
            this.header_class_names = "responsive";
            return this.mobile;
        } else {
            this.mobile = false;
            return this.mobile;
        }
    },
    methods: {
        toggleMenu() {
            this.menu ^= true
            console.log(this.menu)
            console.log(this.mobile)
            if (this.menu == true && this.mobile == true) {
                this.class_name = "fa-times"
                this.header_class_names = "active responsive"
            } else if (this.menu == true && this.mobile == false) {
                this.class_name = "fa-times"
                this.header_class_names = "active"
            } else if (this.menu == false && this.mobile == true) {
                this.class_name = "fa-bars"
                this.header_class_names = "responsive"
            } else {
                this.class_name = "fa-bars"
                this.header_class_names = ""
            }
        },
    },
});