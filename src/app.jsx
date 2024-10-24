import React from "react";
import { BrowserRouter, Routes, Route } from "react-router-dom";

// Layouts
import AppLayout from "@layouts/appLayout.jsx";
import GuestLayout from "@layouts/guestLayout.jsx";
import AdminLayout from "@layouts/adminLayout.jsx";

// Pages
import Login from "@pages/auth/login.jsx";
import Register from "@pages/auth/register.jsx";
import Home from "@pages/home.jsx";
import Products from "@pages/products.jsx";
import UserProfile from "@pages/profile/user.jsx";
import ProductProfile from "@pages/profile/product.jsx";
import Product from "@pages/product.jsx";
import Worker from "@pages/worker.jsx";
import UsersAdmin from "@pages/admin/users.jsx";
import ProductsAdmin from "@pages/admin/products.jsx";

// Contexts
import { AuthProvider } from "@contexts/authContext.jsx";

// MiddleWare
import AuthMiddleware from "@middlewares/authMiddleware.jsx";

export default function App() {
    return (
        <BrowserRouter>
            <AuthProvider>
                <Routes>
                    <Route path="/" element={<AppLayout />}>
                        <Route index element={<Home />} />
                        <Route path="/products" element={<Products />} />
                        <Route path="/product/:id" element={<Product />} />
                        <Route path="/worker/:id" element={<Worker />} />
                        <Route element={<AuthMiddleware />} >
                            <Route path="/profile/user/:id?" element={<UserProfile />} />
                            <Route path="/profile/product/:id" element={<ProductProfile />} />
                            <Route path="/worker/products/:id" element={<div>Productos</div>} />
                            <Route path="/worker/stats/:id" element={<div>Estadisticas</div>} />
                            <Route path="/worker/routes/:id" element={<div>Envios</div>} />
                        </Route>
                    </Route>
                    <Route path="/" element={<GuestLayout />}>
                        <Route element={<AuthMiddleware type="guest" />} >
                            <Route path="login" element={<Login />} />
                            <Route path="register" element={<Register />} />
                        </Route>
                    </Route>
                    <Route path="/" element={<AdminLayout />}>
                        <Route element={<AuthMiddleware />} >
                            <Route path="/admin/products" element={<ProductsAdmin />} />
                            <Route path="/admin/users" element={<UsersAdmin />} />
                        </Route>
                    </Route>
                    <Route path="*" element={<h1>Not found</h1>} />
                </Routes>
            </AuthProvider>
        </BrowserRouter>
    );
}
