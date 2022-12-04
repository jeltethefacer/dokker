import React from "react";

interface UserMenuItem {
  href: string;
  name: string;
}

const userMenuItems: UserMenuItem[] = [
  {
    href: "/user",
    name: "Your profile",
  },
  {
    href: "/orders",
    name: "Orders",
  },
  {
    href: "/logout",
    name: "logout",
  },
];

export default function Navbar(props: { username: string | null }) {
  const [showUserMenu, setShowUserMenu] = React.useState(false);
  const [hoverMenuItem, setHoverMenuItem] = React.useState<string | null>(null);

  return (
    <nav className="bg-gray-800">
      <div className="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
        <div className="relative flex h-16 items-center justify-between">
          <div className="absolute inset-y-0 left-0 flex items-center sm:hidden">
            <button
              type="button"
              className="inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
              aria-controls="mobile-menu"
              aria-expanded="false"
            >
              <span className="sr-only">Open main menu</span>
              <svg
                className="block h-6 w-6"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                strokeWidth="1.5"
                stroke="currentColor"
                aria-hidden="true"
              >
                <path
                  strokeLinecap="round"
                  strokeLinejoin="round"
                  d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"
                />
              </svg>
              <svg
                className="hidden h-6 w-6"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                strokeWidth="1.5"
                stroke="currentColor"
                aria-hidden="true"
              >
                <path
                  strokeLinecap="round"
                  strokeLinejoin="round"
                  d="M6 18L18 6M6 6l12 12"
                />
              </svg>
            </button>
          </div>
          <div className="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
            <div className="hidden sm:ml-6 sm:block">
              <div className="flex space-x-4">
                <a
                  href="/"
                  className="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium"
                  aria-current="page"
                >
                  Homepage
                </a>

                {/* <a */}
                {/*   href="#" */}
                {/*   className="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium" */}
                {/* > */}
                {/*   Team */}
                {/* </a> */}

                {/* <a */}
                {/*   href="#" */}
                {/*   className="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium" */}
                {/* > */}
                {/*   Projects */}
                {/* </a> */}

                {/* <a */}
                {/*   href="#" */}
                {/*   className="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium" */}
                {/* > */}
                {/*   Calendar */}
                {/* </a> */}
              </div>
            </div>
          </div>
          <div className="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
            <div
              className="relative ml-3"
              onFocus={(): void => {
                setShowUserMenu(true);
              }}
              onBlur={(): void => {
                setShowUserMenu(false);
                if (hoverMenuItem) {
                  window.location.href = hoverMenuItem;
                }
              }}
            >
              <>
                {props.username ? (
                  <button
                    type="button"
                    className="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-sm font-medium"
                    id="user-menu-button"
                    aria-expanded="false"
                    aria-haspopup="true"
                  >
                    <span className="sr-only">Open user menu</span>
                    {props.username}
                  </button>
                ) : (
                  <a
                    href="/login"
                    className="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium"
                    aria-current="page"
                  >
                    Login
                  </a>
                )}
              </>

              {showUserMenu && props.username && (
                <div
                  className="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                  role="menu"
                  aria-orientation="vertical"
                  aria-labelledby="user-menu-button"
                  tabIndex={-1}
                >
                  {userMenuItems.map((userMenuitem): JSX.Element => {
                    return (
                      <a
                        key={userMenuitem.href}
                        href={userMenuitem.href}
                        onMouseEnter={() => setHoverMenuItem(userMenuitem.href)}
                        onMouseLeave={() => setHoverMenuItem(null)}
                        className="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-200"
                        role="menuitem"
                        tabIndex={-1}
                        id="user-menu-item-0"
                      >
                        {userMenuitem.name}
                      </a>
                    );
                  })}
                </div>
              )}
            </div>
          </div>
        </div>
      </div>

      <div className="sm:hidden" id="mobile-menu">
        <div className="space-y-1 px-2 pt-2 pb-3">
          <a
            href="/"
            className="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-sm font-medium"
            aria-current="page"
          >
            Homepage
          </a>

          {/* <a */}
          {/*   href="#" */}
          {/*   className="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium" */}
          {/* > */}
          {/*   Team */}
          {/* </a> */}

          {/* <a */}
          {/*   href="#" */}
          {/*   className="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium" */}
          {/* > */}
          {/*   Projects */}
          {/* </a> */}

          {/* <a */}
          {/*   href="#" */}
          {/*   className="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium" */}
          {/* > */}
          {/*   Calendar */}
          {/* </a> */}
        </div>
      </div>
    </nav>
  );
}
