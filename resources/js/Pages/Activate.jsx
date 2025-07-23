import { useForm, usePage } from "@inertiajs/react";
import { useState, useEffect, useRef } from "react";
import toast, { Toaster } from "react-hot-toast";

const Activate = ({ users }) => {
  const [activeDropdown, setActiveDropdown] = useState(null);
  const dropdownRefs = useRef({}); // Store multiple refs

  /* // Close dropdown when clicking outside
  useEffect(() => {
    const handleClickOutside = (e) => {
      if (
        activeDropdown !== null &&
        dropdownRefs.current[activeDropdown] &&
        !dropdownRefs.current[activeDropdown].contains(e.target)
      ) {
        setActiveDropdown(null);
      }
    };
    document.addEventListener("mousedown", handleClickOutside);
    return () => document.removeEventListener("mousedown", handleClickOutside);
  }, [activeDropdown]); */

  const { flash } = usePage().props;

  useEffect(() => {
    if (flash?.message) {
      if (flash?.code && flash.code == 200) {
        toast.success(flash.message);
        const audio = new Audio(`/storage/audio/${flash.audio}`);
        audio.play();
      } else {
        toast.error(flash.message);
        const audio = new Audio(`/storage/audio/${flash.audio}`);
        audio.play();
      }
    }
  }, [flash])

  const { post, processing } = useForm();
 
  const handleActivate = (userId) => {
    post(`/admin/activate-supervisor-account/${userId}`, {
      preserveScroll: true,
      onFinish: () => setActiveDropdown(null),
    })
  };
  
  const handleDisactivate = (userId) => {
    post(`/admin/disactivate-supervisor-account/${userId}`, {
      preserveScroll: true,
      onFinish: () => setActiveDropdown(null),
    }) 
  };

  return (
    <div className="w-3xl mx-auto bg-white shadow-lg rounded-md px-4 py-2">
      <Toaster position="top-center"/>
      <p className="text-lg font-medium text-gray-600">Supervisor Management</p>
      <table className="min-w-full border border-gray-200 shadow-sm rounded-md">
        <thead className="bg-blue-600">
          <tr className="font-semibold text-white text-sm">
            <th className="px-4 py-2">No</th>
            <th className="px-4 py-2">Name</th>
            <th className="px-4 py-2">Email</th>
            <th className="px-4 py-2">Status</th>
            <th className="px-4 py-2">Actions</th>
          </tr>
        </thead>
        <tbody className="text-sm text-gray-600 text-center">
          {users.map((user, index) => (
            <tr key={user.id} className="hover:bg-gray-50">
              <td className="px-4 py-2">{index + 1}</td>
              <td className="px-4 py-2">{user.name}</td>
              <td className="px-4 py-2">{user.email}</td>
              <td className="px-4 py-2">
                {user.allow_access == 1 ? "Activate" : "Inactivate"}
              </td>
              <td
                className="px-4 py-2 relative"
                ref={(el) => (dropdownRefs.current[user.id] = el)}
              >
                <button
                  onClick={() =>
                    setActiveDropdown(activeDropdown === user.id ? null : user.id)
                  }
                  className="px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700"
                >
                  Actions
                </button>

                {activeDropdown === user.id && (
                  <div className="absolute right-0 mt-2 bg-white border border-gray-200 rounded shadow-md z-50">
                    <p
                      className="px-4 py-2 hover:bg-gray-100 cursor-pointer"
                      onClick={() => handleActivate(user.id)}
                    >
                      ✅ Activate
                    </p>
                    <p
                      className="px-4 py-2 hover:bg-gray-100 cursor-pointer"
                      onClick={() => handleDisactivate(user.id)}
                    >
                      🚫 Disactivate
                    </p>
                  </div>
                )}
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
};

export default Activate;
