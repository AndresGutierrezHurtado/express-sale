import React from "react";
import { BrowserRouter, Routes, Route } from "react-router-dom";

// Layouts
import AppLayout from "@layouts/appLayout.jsx";
import GuestLayout from "@layouts/guestLayout.jsx";
import AdminLayout from "@layouts/adminLayout.jsx";
import WorkerLayout from "@layouts/workerLayout.jsx";

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
import WorkerDeliveries from "@pages/profile/worker/deliveries.jsx";
import WorkerProducts from "@pages/profile/worker/products.jsx";
import WorkerStats from "@pages/profile/worker/stats.jsx";
import Cart from "@pages/pay/cart.jsx";
import PayForm from "@pages/pay/payForm";

// Contexts
import { AuthProvider } from "@contexts/authContext.jsx";

// MiddleWare
import AuthMiddleware from "@middlewares/authMiddleware.jsx";

export default function App() {
    return (
        <BrowserRouter>
            <AuthProvider>
                <Routes>
                    {/* Auth needed routes */}
                    <Route element={<AuthMiddleware />}>
                        <Route path="/" element={<AppLayout />}>
                            <Route path="/profile/user/:id?" element={<UserProfile />} />
                            <Route path="/profile/product/:id" element={<ProductProfile />} />
                            <Route path="/cart" element={<Cart />} />
                        </Route>
                        <Route path="/" element={<AdminLayout />}>
                            <Route path="/admin/products" element={<ProductsAdmin />} />
                            <Route path="/admin/users" element={<UsersAdmin />} />
                        </Route>
                        <Route path="/" element={<WorkerLayout />}>
                            <Route path="/worker/products/:id" element={<WorkerProducts />} />
                            <Route path="/worker/stats/:id" element={<WorkerStats />} />
                            <Route path="/worker/deliveries/:id" element={<WorkerDeliveries />} />
                        </Route>
                        <Route path="/" element={<GuestLayout />}>
                            <Route path="/payform" element={<PayForm />} />
                        </Route>
                    </Route>
                    {/* must not be auth */}
                    <Route path="/" element={<GuestLayout />}>
                        <Route element={<AuthMiddleware type="guest" />}>
                            <Route path="login" element={<Login />} />
                            <Route path="register" element={<Register />} />
                        </Route>
                    </Route>
                    {/* Auth not needed routes */}
                    <Route path="/" element={<AppLayout />}>
                        <Route index element={<Home />} />
                        <Route path="/products" element={<Products />} />
                        <Route path="/product/:id" element={<Product />} />
                        <Route path="/worker/:id" element={<Worker />} />
                    </Route>
                    <Route path="*" element={<h1>Not found</h1>} />
                </Routes>
            </AuthProvider>
        </BrowserRouter>
    );
}
