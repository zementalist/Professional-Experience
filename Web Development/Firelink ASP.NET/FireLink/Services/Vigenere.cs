using System;
using System.Collections.Generic;
using System.Linq;
using System.Text.RegularExpressions;
using System.Web;

namespace FireLink.Services
{
    public class Vigenere
    {
        public static char[] getRowOf2D(char[,] matrix, int RowIndex)
        {
            return Enumerable.Range(0, matrix.GetLength(0))
                      .Select(i => matrix[RowIndex, i])
                      .ToArray();
        }

        public int n_chars;
        public char[,] matrix;
        public char[] alphabet;

        public Vigenere()
        {
            n_chars = 62;
            matrix = new char[n_chars, n_chars];
            alphabet = new char[] { 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z' };
            for (int i = 0; i < n_chars; i++)
            {
                for (int j = 0; j < n_chars; j++)
                {
                    matrix[i, j] = alphabet[(i + j) % n_chars];
                }
            }
        }

        public string full_key(string text, string key)
        {
            var char_rprsnt = new int[text.Length];
            int j = 0;
            for (int i = 0; i < text.Length; i++)
            {
                int cipher = -1;
                if (text[i] != ' ')
                {
                    cipher = key[j % key.Length];
                    j += 1;
                }
                char_rprsnt[i] = cipher;
            }
            string cipher_text = "";
            char[] firstRow = getRowOf2D(matrix, 0);
            for (int i = 0; i < text.Length; i++)
            {
                if (char_rprsnt[i] == -1)
                {
                    cipher_text += ' ';
                    continue;
                }

                int rowIndex = Array.IndexOf(firstRow, (char)text[i]);
                int colIndex = Array.IndexOf(firstRow, (char)char_rprsnt[i]);
                System.Diagnostics.Debug.WriteLine(rowIndex);
                System.Diagnostics.Debug.WriteLine(colIndex);
                System.Diagnostics.Debug.WriteLine("\n");
                cipher_text += matrix[rowIndex, colIndex];
            }
            return cipher_text;
        }

        public string full_key_decrypt(string cipher, string key)
        {
            var char_rprsnt = new int[cipher.Length];
            int j = 0;
            for (int i = 0; i < cipher.Length; i++)
            {
                int plain_char_rprsnt = -1;
                if (cipher[i] != ' ')
                {
                    plain_char_rprsnt = key[j % key.Length];
                    j += 1;
                }
                char_rprsnt[i] = plain_char_rprsnt;
            }
            string plain_text = "";
            char[] firstRow = getRowOf2D(matrix, 0);
            for (int i = 0; i < cipher.Length; i++)
            {
                if (char_rprsnt[i] == -1)
                {
                    plain_text += ' ';
                    continue;
                }
                int rowIndex = Array.IndexOf(firstRow, (char)char_rprsnt[i]);
                char[] rowOfCipherChar = getRowOf2D(matrix, rowIndex);
                int plain_char_col_index = Array.IndexOf(rowOfCipherChar, (char)cipher[i]);
                char plain_char = (char)firstRow[plain_char_col_index];

                plain_text += plain_char;
            }
            return plain_text;
        }
    }
}