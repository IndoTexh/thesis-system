// resources/js/Layouts/Layout.jsx

import { Link, usePage } from "@inertiajs/react";

const Layout = ({ children }) => {
  const { auth } = usePage().props;

  return (
    <div className="min-h-screen flex flex-col bg-gray-50 text-gray-800">
      <header className="bg-white shadow">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
          <h1 className="text-xl font-semibold text-blue-600">
            Thesis Portal
          </h1>

          <nav className="space-x-4">
            
            {!auth?.user ? (
              <Link href="/" className="text-gray-700 hover:text-blue-600 font-medium">
              Home
            </Link>
            ) : '' }
            

            {auth?.user?.role === 'student' && (
              <Link href="/thesis/upload" className="text-gray-700 hover:text-blue-600 font-medium">
                Upload Thesis
              </Link>
            )}

            {auth?.user?.role === 'supervisor' && (
              <Link href="/supervisor/dashboard" className="text-gray-700 hover:text-blue-600 font-medium">
                Supervisor Panel
              </Link>
            )}

            {auth?.user?.role === 'admin' && (
              <Link href="/admin/dashboard" className="text-gray-700 hover:text-blue-600 font-medium">
                Admin
              </Link>
            )}

            {auth?.user ? (
              <Link href="/logout" method="post" as="button" className="text-red-500 font-medium">
                Logout
              </Link>
            ) : (
              <Link href="/login" className="text-blue-600 font-medium">
                Login
              </Link>
            )}
          </nav>
        </div>
      </header>

      <main className="flex-grow max-w-7xl mx-auto px-4 py-6">
        {children}
      </main>

      <footer className="bg-white text-center text-sm text-gray-500 py-4 border-t">
        © {new Date().getFullYear()} BELTEI International University — Thesis Portal
      </footer>
    </div>
  );
};

export default Layout;
