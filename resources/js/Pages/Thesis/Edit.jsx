import { Link, useForm, usePage } from "@inertiajs/react"
import { useEffect } from "react";
import toast, { Toaster } from "react-hot-toast";

const Edit = ({thesis}) => {
  const { data, setData, post, errors, processing } = useForm({
    title: thesis.title,
    abstract: thesis.abstract,
    document: null
  });

  const handleSubmit = (e) => {
    e.preventDefault();
    post(`/student/theses/${thesis.id}/update`, {
      forceFormData: true,
    });
  }

  return (
    <div className="max-w-xl mx-auto mt-10 p-6 bg-white shadow rounded space-y-4">
      <h2 className="text-xl font-bold mb-4 text-blue-600">
        Edit Thesis
      </h2>
      <form onSubmit={handleSubmit}>
        <div>
          <label>Title</label>
          <input 
          type="text" 
          className="w-full border p-2 rounded mt-1" 
          value={data.title}
          onChange={(e) => setData('title', e.target.value)}
          />
          {errors.title && <div className="text-red-500 text-sm">{errors.title}</div>}
        </div>

        <div className="mt-5">
          <label>Abstract</label>
          <textarea
            value={data.abstract}
            onChange={(e) => setData('abstract', e.target.value)}
            className="w-full border p-2 rounded"
          />
          {errors.abstract && <div className="text-red-500 text-sm">{errors.abstract}</div>}
        </div>

        <div className="mt-5">
            <label className="block mb-1 font-medium">Replace File (optional)</label>
            <div className="relative">
              <label className="flex items-center justify-center px-4 py-2 bg-gray-100 border border-gray-300 rounded cursor-pointer hover:bg-gray-200 transition duration-200">
                <span className="text-sm text-gray-700">Choose File</span>
                <input
                  type="file"
                  onChange={(e) => setData('document', e.target.files[0])}
                  className="absolute inset-0 opacity-0 cursor-pointer"
                />
              </label>
              {data.document && (
                <p className="text-sm text-gray-600 mt-2">
                  Selected: <span className="font-medium">{data.document.name}</span>
                </p>
              )}
            </div>
          </div>

          <div className="mt-2">
            <button type="submit" className="bg-blue-600 text-white px-4 py-2 rounded">
               Update Thesis
            </button>
            <Link href="/student/theses" className="ml-4 text-gray-500 hover:underline">Cancel</Link>
          </div>
      </form>
    </div>
  )
}

export default Edit
