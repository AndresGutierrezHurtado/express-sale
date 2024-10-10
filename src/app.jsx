import React from "react";
import { BrowserRouter, Routes, Route } from "react-router-dom";

// Layouts
import AppLayout from "./layouts/appLayout";
import GuestLayout from "./layouts/guestLayout";

// Pages
import Login from "./pages/auth/login";
import Register from "./pages/auth/register";
import Home from "./pages/home";
import Products from "./pages/products";
import UserProfile from "./pages/profile/user";

// Contexts
import { AuthProvider } from "./context/authContext";

// MiddleWare
import AuthMiddleware from "./middleWares/authMiddleware";

export default function App() {
    return (
        <BrowserRouter>
            <AuthProvider>
                <Routes>
                    <Route path="/" element={<AppLayout />}>
                        <Route index element={<Home />} />
                        <Route path="/products" element={<Products />} />
                        <Route path="/product/:id" element={<h1>adfsadfas</h1>} />
                        <Route element={<AuthMiddleware />} >
                            <Route path="/profile/user/:id?" element={<UserProfile />} />
                            <Route path="/profile/product/:id?" element={<h1>hola mundo</h1>} />
                        </Route>
                    </Route>
                    <Route path="/" element={<GuestLayout />}>
                        <Route element={<AuthMiddleware type="guest" />} >
                            <Route path="login" element={<Login />} />
                            <Route path="register" element={<Register />} />
                        </Route>
                    </Route>
                    <Route path="*" element={<h1>Not found</h1>} />
                </Routes>
            </AuthProvider>
        </BrowserRouter>
    );
}
