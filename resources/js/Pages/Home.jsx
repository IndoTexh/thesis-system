// resources/js/Pages/Home.jsx

import { Link, usePage } from "@inertiajs/react";
import { useEffect } from "react";
import toast, { Toaster } from "react-hot-toast";

const Home = () => {
  const { flash } = usePage().props;
  const { auth } = usePage().props;

  useEffect(() => {
    if(flash?.message) {
      toast(flash.message);
    }
  }, [flash]);

  return (
    <div className="bg-white rounded-lg shadow p-8 space-y-6">
      {/* Welcome Heading */}
      <Toaster position="top-center"/>
      <div className="text-center">
        <h1 className="text-3xl font-bold text-blue-600">Welcome to the Thesis Portal</h1>
        <p className="text-gray-600 mt-2 text-lg">
          A centralized platform for submitting, reviewing, and managing thesis documents at BELTEI International University.
        </p>
      </div>

      {/* Info Cards */}
      <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
        <div className="border rounded p-4 text-center shadow-sm bg-blue-50">
          <h3 className="text-lg font-semibold text-blue-700">Students</h3>
          <p className="text-gray-600 mt-2 text-sm">
            Upload your thesis, track feedback, and stay updated on approval status.
          </p>
        </div>

        <div className="border rounded p-4 text-center shadow-sm bg-green-50">
          <h3 className="text-lg font-semibold text-green-700">Supervisors</h3>
          <p className="text-gray-600 mt-2 text-sm">
            Review and provide structured feedback for your students’ submissions.
          </p>
        </div>

        <div className="border rounded p-4 text-center shadow-sm bg-yellow-50">
          <h3 className="text-lg font-semibold text-yellow-700">Admin</h3>
          <p className="text-gray-600 mt-2 text-sm">
            Manage users, monitor thesis activity, and maintain digital archives.
          </p>
        </div>
      </div>

      {/* Action Buttons */}
      <div className="text-center mt-8">
        {auth?.user ? (
          <Link
           /*  href={
              auth.user.role === "student"
                ? "/thesis/upload"
                : auth.user.role === "supervisor"
                ? "/supervisor/dashboard"
                : "/admin/dashboard"
            } */
           href="/dashboard"
            className="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded"
          >
            Go to Dashboard
          </Link>
        ) : (
          <>
            {/* <Link
              href="/login"
              className="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded"
            >
              Login
            </Link>
            <span className="mx-2 text-gray-500">or</span>
            <Link
              href="/register"
              className="bg-gray-100 hover:bg-gray-200 px-6 py-2 rounded text-gray-800"
            >
              Register
            </Link> */}
          </>
        )}
      </div>
    </div>
  );
};

export default Home;
