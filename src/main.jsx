import { StrictMode } from 'react'
import { createRoot } from 'react-dom/client'
import App from './app.jsx';
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";
import './index.css'

createRoot(document.getElementById('root')).render(
  <StrictMode>
    <App />
  </StrictMode>,
)
