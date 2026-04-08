/**
 * @license
 * SPDX-License-Identifier: Apache-2.0
 */

import { BrowserRouter, Routes, Route } from 'react-router-dom';
import Layout from './components/Layout';
import Home from './pages/Home';
import ServiceDetails from './pages/ServiceDetails';
import BookingFlow from './pages/BookingFlow';

export default function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<Layout />}>
          <Route index element={<Home />} />
          <Route path="service/:id" element={<ServiceDetails />} />
          <Route path="book/:id" element={<BookingFlow />} />
        </Route>
      </Routes>
    </BrowserRouter>
  );
}
