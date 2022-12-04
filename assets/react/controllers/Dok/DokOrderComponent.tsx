import React, { useState } from "react";
import axios, { AxiosResponse } from "axios";

interface ProductSearchParameters {
  name: string | null;
  price: number | null;
}

interface Product {
  id: number;
  name: string;
  price_minor_amount: number;
  currency_id: string;
}

interface Cart {
  cart_items: CartItem[];
}

interface CartItem {
  product_id: number;
  quantity: number;
}

export default function DokOrderComponent(props: { products: Product[] }) {
  const [cart, setCart] = useState<Cart>({
    cart_items: [],
  });

  const addProduct = (productId: number) => {
    setCart((prevCart) => {
      let alreadyInCart = false;
      const newCartItems = cart.cart_items.map((cartItem) => {
        if (cartItem.product_id === productId) {
          alreadyInCart = true;
          return {
            ...cartItem,
            quantity: cartItem.quantity + 1,
          };
        }

        return {
          ...cartItem,
        };
      });

      if (!alreadyInCart) {
        newCartItems.push({
          quantity: 1,
          product_id: productId,
        });
      }

      return {
        ...cart,
        cart_items: newCartItems,
      };
    });
  };

  return (
    <div className="grid grid-cols-1 sm:grid-cols-3">
      <div className="grid grid-cols-4 gap-4 col-span-2">
        {props.products.map((product: Product) => {
          return (
            <div
              key={product.id}
              className="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700"
              onClick={(): void => addProduct(product.id)}
              onKeyDown={(): void => addProduct(product.id)}
            >
              <h5 className="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                {product.name}
              </h5>

              <p className="mb-3 font-normal text-gray-700 dark:text-gray-400">
                {product.price_minor_amount}
              </p>
              <button
                type="button"
                className="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
              >
                Add
              </button>
            </div>
          );
        })}
      </div>
      <>
        <table className="w-full text-sm text-left text-gray-500 dark:text-gray-400">
          <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
              <th scope="col" className="py-3 px-6">
                Product
              </th>
              <th scope="col" className="py-3 px-6">
                Qty.
              </th>
              <th scope="col" className="py-3 px-6">
                Unit
              </th>
              <th scope="col" className="py-3 px-6">
                Sum
              </th>
            </tr>
          </thead>
          <tbody>
            {cart.cart_items.map((cartItem) => {
              const product = props.products.find(
                (product): boolean => product.id === cartItem.product_id
              );
              if (!product) {
                return <div key={cartItem.product_id} />;
              }
              return (
                <tr
                  key={cartItem.product_id}
                  className="bg-white border-b dark:bg-gray-900 dark:border-gray-700"
                >
                  <td className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {product.name}
                  </td>
                  <td className="py-4 px-6">{cartItem.quantity}</td>
                  <td className="py-4 px-6">{product.price_minor_amount}</td>
                  <td className="py-4 px-6">
                    {product.price_minor_amount * cartItem.quantity}
                  </td>
                </tr>
              );
            })}
            <tr className="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
              <td className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                Total
              </td>
              <td className="py-4 px-6" />
              <td className="py-4 px-6" />
              <td className="py-4 px-6">
                {cart.cart_items.reduce((sum, cartItem) => {
                  const product = props.products.find(
                    (product): boolean => product.id === cartItem.product_id
                  );
                  if (!product) {
                    return sum;
                  }
                  return sum + cartItem.quantity * product.price_minor_amount;
                }, 0)}
              </td>
            </tr>
          </tbody>
        </table>
      </>
    </div>
  );
}
