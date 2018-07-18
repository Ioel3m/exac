import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
  name: 'capitalizar'
})
export class CapitalizarPipe implements PipeTransform {

  transform(value: string, args?: string): any {
    if(value == null)  return "No asignado";
    return value.charAt(0).toUpperCase() + value.slice(1);
  }

}
