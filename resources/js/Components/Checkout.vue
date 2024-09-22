<template>
    <div>
        <form @submit.prevent="submitOrder">
            <div>
                <label for="menu">Menu</label>
                <select v-model="selectedMenu" id="menu">
                    <option
                        v-for="menu in menus"
                        :key="menu.id"
                        :value="menu.id"
                    >
                        {{ menu.name }}
                    </option>
                </select>
            </div>

            <div>
                <label for="quantity">Quantity</label>
                <input type="number" v-model="quantity" id="quantity" />
            </div>

            <div>
                <label for="delivery_date">Delivery Date</label>
                <input type="date" v-model="deliveryDate" id="delivery_date" />
            </div>

            <button type="submit">Order</button>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            menus: [],
            selectedMenu: null,
            quantity: 1,
            deliveryDate: "",
        };
    },
    mounted() {
        axios.get("/api/menus").then((response) => {
            this.menus = response.data;
        });
    },
    methods: {
        submitOrder() {
            axios
                .post("/api/orders", {
                    menu_id: this.selectedMenu,
                    quantity: this.quantity,
                    delivery_date: this.deliveryDate,
                })
                .then((response) => {
                    alert("Order placed successfully!");
                })
                .catch((error) => {
                    console.error(error);
                    alert("Failed to place order.");
                });
        },
    },
};
</script>
