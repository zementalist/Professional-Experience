

org 100h

.data  

myArray db 9,4,8,3,7,1,0,5,2,6
arrSize db 10d

beforeMsg db "Before sort: $"
afterMsg db 13, 10, "After sort: $"

.code



main PROC

    ; Display array before sort
	call display_unsorted_array
	

	; Do the bubble sort
	call bubble_sort
	
    
    ; Display array after sort
	call display_sorted_array
	
	ret
main endp

display_unsorted_array PROC
    
    ; Clear Registers
    call clearRegisters
    
    ; display msg 
	lea dx, beforeMsg
    mov ah, 09h
    int 21h
    
	; Keep array size
    mov bl, arrSize 
    
    ; Loop over array
    getNextItem:
        mov si, cx
        mov dl, myArray[si]
        add dl, 48d
        inc cl
        mov ah, 02h
        int 21h
        cmp cl, bl
        jne getNextItem 
    or ax , -1    
    ret
display_unsorted_array endp

bubble_sort PROC
    ; Clear Registers
    call clearRegisters
    
    ; keep array size
    mov dh, arrSize
    mov ah, dh
	outerLoop:
	; Clear some Registers
    mov al, 00h
	mov bx, 0000h
	mov cx, 0000h

	innerLoop:

	inc bl
	mov si, cx
	mov al, myArray[si]
	mov si, bx
	cmp al, myArray[si]
	js noSwap
	; Compare consequent elements
	mov si, cx
	mov al, myArray[si]
	mov si, bx
	xchg al, myArray[si]
	mov si, cx
	xchg al, myArray[si]
	noSwap:
	; Increment iterators
	inc cl
	cmp bl, ah
	jne innerLoop
	; To the next outer loop
	dec ah
	inc dl
	cmp dl, dh
	jne outerLoop
	
    ret
bubble_sort endp

display_sorted_array PROC
    
    ; Clear Registers
    call clearRegisters
	
	; display msg
	lea dx, afterMsg
    mov ah, 09h
    int 21h
    
	; Keep array size
    mov bl, arrSize 
    
    ; Loop over array
    get_next_item:
        mov si, cx
        mov dl, myArray[si]
        add dl, 48d
        inc cl
        mov ah, 02h
        int 21h
        cmp cl, bl
        jne get_next_item 
    or ax , -1    
    ret
display_sorted_array endp
   
   
clearRegisters PROC
    mov ax, 0000h
	mov bx, 0000h
	mov cx, 0000h
	mov dx, 0000h
    ret
clearRegisters endp
   
end main    






