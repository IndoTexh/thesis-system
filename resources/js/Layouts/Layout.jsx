// resources/js/Layouts/Layout.jsx

import { Link, usePage } from "@inertiajs/react";
import { useState } from "react";

const Layout = ({ children }) => {
  const { auth } = usePage().props;

  const [showMenu, setShowMenu] = useState(false);

  return (
    <div className="min-h-screen flex flex-col bg-gray-50 text-gray-800">
      <header className="bg-white shadow">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
          <h1 className="text-xl font-semibold text-blue-600">
            Thesis Portal
          </h1>

          <nav className="space-x-4 relative">

            {auth?.user ? (
              <button onClick={() => setShowMenu(!showMenu)} className="bg-blue-600 text-white px-4 py-1 w-[220px] text-sm">
                {auth?.user ? `Welcome, ${auth.user.name}` : ''}
              </button>
            ) : (
              <Link href="/login" className="text-blue-600 font-medium">
                Login
              </Link>
            )}

          
            {showMenu ? (
              <div onClick={() => setShowMenu(!showMenu)}  className="flex flex-col bg-blue-600 space-y-4 p-2 absolute w-[220px]  left-0 rounded-b-md border-t border-white">
              {auth?.user ? (
              <Link href="/" className="text-white  font-medium">
                Home
              </Link>
            ) : '' }

            {auth?.user ? (
              <Link href="/student/profile" className="text-white  font-medium">
                My profile
              </Link>
            ) : '' }

             {auth?.user?.role === 'student' && (
              <Link href="/student/theses" className="text-white  font-medium">
                My theses
              </Link>
            )}

             {auth?.user?.role === 'admin' ? (
              <Link href="/dashboard" className="text-white  font-medium">
                Dashboard
              </Link>
            ) : (
              <Link href="/student/profile/upload" className="text-white  font-medium">Upload profile</Link>
            ) }

           

            {auth?.user?.role === 'supervisor' && (
              <Link href="/supervisor/dashboard" className="text-gray-700  font-medium">
                Supervisor Panel
              </Link>
            )}

            {auth?.user?.role === 'admin' && (
              <Link href="/admin/dashboard" className="text-gray-700  font-medium">
                Admin
              </Link>
            )}

            {auth?.user ? (
              <Link href="/logout" method="post" as="button" className="text-white font-medium text-left hover:cursor-pointer">
                Logout
              </Link>
            ) : '' }
            </div>
            ) : ''}

          </nav>
        </div>
      </header>

      <main className="flex-grow max-w-7xl mx-auto px-4 py-6">
        {children}
      </main>

      <footer className="bg-white text-center text-sm text-gray-500 py-4 border-t">
        © {new Date().getFullYear()} BELTEI International University — {/* Thesis Portal */} Developed by: <span className="text-blue-600 font-medium">Doeuk Sothanroth</span>
      </footer>
    </div>
  );
};

export default Layout;
