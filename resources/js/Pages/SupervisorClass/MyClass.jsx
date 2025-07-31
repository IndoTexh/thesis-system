import { Link } from "@inertiajs/react";

const MyClass = ({ supervisor }) => {
  return (
    <div className="max-w-6xl mx-auto p-6">
      <h1 className="text-3xl text-gray-800 font-bold mb-6">Supervised Classes</h1>

      {supervisor.supervised_classes.length > 0 ? (
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          {supervisor.supervised_classes.map((cls) => (
            <Link href={`/supervisor/${cls.id}/class-students`}>
              <div
              key={cls.id}
              className="bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-200 p-5"
              >
                <img
                  src="/storage/profiles/graduation.png"
                  alt="Class"
                  className="w-16 h-16 object-contain mb-4"
                />
                <h2 className="text-xl font-semibold text-gray-700">
                  {cls.class_name}
                </h2>
                <p className="text-sm text-gray-500 mt-1">
                  Directed by: <span className="font-medium text-gray-700">{supervisor.name}</span>
                </p>
              </div>
            </Link>
          ))}
        </div>
      ) : (
        <div className="text-gray-500 italic">You are not supervising any classes yet.</div>
      )}
    </div>
  );
};

export default MyClass;
