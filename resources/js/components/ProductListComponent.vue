<script>
import axios from "axios";

export default {
    data() {
        return {
            offset: 0,
            limit: 15,
            isLoadingProducts: true,
            errorOcurred: false,
            products: []
        };
    },
    async created() {
        this.getProducts();
    },
    methods: {
        async getProducts() {
            let resp = null;

            try {
                resp = await axios.get(
                    `/api/products?offset=${this.offset}&limit=${this.limit}`
                );
            } catch (ex) {
                console.error(ex);
                this.errorOcurred = true;
                return;
            }

            if (resp && resp.status === 200) {
                this.products = await resp.data;
                this.isLoadingProducts = false;
            }
        }
    }
};
</script>

<template>
    <div v-if="isLoadingProducts">
        <div class="d-flex align-items-center">
            <strong>Cargando Productos...</strong>
            <div
                class="spinner-border ml-auto"
                role="status"
                aria-hidden="true"
            ></div>
        </div>
    </div>
    <div v-else>
        <div class="card">
            <div class="card-header">
                Lista de Productos
            </div>

            <div class="card-body">
                <table v-if="products.length > 0" class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Precio</th>
                            <th scope="col">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="product in products" :key="product.id">
                            <th scope="row">{{ product.id }}</th>
                            <td>{{ product.name }}</td>
                            <td>{{ product.description }}</td>
                            <td>{{ product.price }}</td>
                            <td>
                                <div
                                    class="btn-group"
                                    role="group"
                                    aria-label="Basic example"
                                >
                                    <button
                                        type="button"
                                        class="btn btn-secondary"
                                    >
                                        Left
                                    </button>
                                    <button
                                        type="button"
                                        class="btn btn-secondary"
                                    >
                                        Middle
                                    </button>
                                    <button
                                        type="button"
                                        class="btn btn-secondary"
                                    >
                                        Right
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <h2 v-else>No hay productos registrados.</h2>
            </div>
        </div>
    </div>
</template>
