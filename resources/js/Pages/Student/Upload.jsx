import { useForm, usePage } from "@inertiajs/react"
import { useEffect } from "react";
import toast, { Toaster } from "react-hot-toast";

const Index = () => {
  const { flash } = usePage().props;
  
  useEffect(() => {
    if (flash?.message) {
      toast.success(flash.message);
    }
  }, [flash]);

  const {data, setData, post, processing, errors} = useForm({
    profile_photo: null,
  });

  const handleSubmit = (e) => {
    e.preventDefault();
    post('/student/profile/upload', {
      forceFormData: true
    });
  }

  return (
     <div className="max-w-md mx-auto mt-10 space-y-4 bg-white p-4 rounded shadow">
      <Toaster position="top-center"/>
      <h2 className="text-xl font-semibold">Upload Profile Photo</h2>
      <form onSubmit={handleSubmit}>
        <input 
          type="file"
          onChange={(e) => setData('profile_photo', e.target.files[0])}
          className="block w-full mb-2"
        />
       {errors.profile_photo && 
       <div className="text-red-500 text-sm">{errors.profile_photo}</div>
       }
        <button disabled={processing} className="disabled:bg-blue-300 disabled:cursor-wait bg-blue-600 text-white px-4 py-2 rounded cursor-pointer">
          Upload
        </button>
      </form>
    </div>
  )
}

export default Index
