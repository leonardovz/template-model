<?php

namespace App\Models;

use App\Config\MySql;
use App\Database\Database;
use InvalidArgumentException;

class BaseModel
{
    protected $table;
    protected $filters   = [];

    protected $limite    = 22;
    protected $pagina    = 1;

    protected $orderBy   = null; // Propiedad para manejar el ORDER BYç
    protected $DataBase;

    public function __construct($table)
    {
        $this->table = $table;
        $this->DataBase = new Database();
    }

    // Filtros para las consultas (fluent interface)
    public function filter($column, $operator, $value)
    {
        // Agregar un nuevo filtro a la lista de filtros.
        $this->filters[] = [
            'column'    => $column,
            'operator'  => $operator,
            'value'     => $value,
        ];
        return $this; // Retorna la misma instancia para encadenar.
    }
    public function clear_point($str)
    {
        return str_replace(['.', ' '], '', $str);
    }

    public function filterClauses()
    {
        if (empty($this->filters)) return null;

        $clauses = [];
        $params  = [];

        foreach ($this->filters as $filter) {
            $column = $this->clear_point($filter['column']);
            $clauses[] = "{$filter['column']} {$filter['operator']} :$column";
            $params[$column]  = $filter['value'];
        }


        $where = "WHERE " . implode(" AND ", $clauses);
        return [$where, $params]; // Retorna la cláusula WHERE completa y los parametros.
    }


    /** START PAGINACION */
    public function limite($limit)
    {
        $this->limite = $limit;
        return $this; // Retorna la misma instancia para encadenar
    }
    public function pagina($offset)
    {
        $this->pagina = $offset;
        return $this; // Retorna la misma instancia para encadenar
    }
    public function paginacion()
    {
        $limite = $this->limite;
        $pagina = ($this->pagina > 0) ? ($this->pagina - 1) * $limite : 0;
        return ($limite !== false) ? "LIMIT $limite OFFSET $pagina" : "";
    }
    /** END PAGINACION */


    // Ordenar los resultados
    public function order($order)
    {
        $this->orderBy = $order;
        return $this;
    }

    public function getOrderBy()
    {
        if (empty($this->orderBy)) return ''; // Si no hay filtros, no se agrega la cláusula WHERE.
        $columns = $this->orderBy;

        if (is_array($columns) && isset($columns[0]) && is_string($columns[0])) {
            $columns = [$columns];
        }

        foreach ($columns as $column) {
            if (count($column) !== 2 || !is_string($column[0]) || !in_array(strtoupper($column[1]), ['ASC', 'DESC'])) {
                throw new InvalidArgumentException("Cada elemento debe ser un array con [columna, dirección]. Dirección debe ser 'ASC' o 'DESC'.");
            }
        }

        $orderByClauses = [];
        foreach ($columns as $column) {
            $orderByClauses[] = "{$column[0]} {$column[1]}"; // Genera cada parte del ORDER BY
        }

        // Retornar la cláusula ORDER BY como una cadena SQL
        return 'ORDER BY ' . implode(', ', $orderByClauses); // Unimos con comas y retornamos
    }

    // Mostrar registros con filtros, ordenamiento y paginación
    public function mostrar()
    {
        $params = [];

        // Filtros
        $filtro = $this->filterClauses();
        $limite = $this->paginacion();
        $order  = $this->getOrderBy();


        if ($filtro) {
            $params = array_merge($params, $filtro[1]);
            $filtro = $filtro[0];
        }

        $sql = "SELECT * FROM {$this->table} $filtro $order $limite";

        // echo json_encode($params);
        // echo $sql;

        return $this->DataBase->fetchAll($sql, $params);
    }

    // Crear un registro
    public function create($data)
    {

        $fields = implode(", ", array_keys($data));
        $placeholders = [];

        foreach ($data as $key => $value) {
            // Si el valor es una función SQL (ejemplo: UUID()), no usar placeholder
            if (preg_match('/\(\)$/', $value)) {
                $placeholders[] = $value;
                unset($data[$key]); // Elimina para evitar duplicados en bindParam
            } else {
                $placeholders[] = ":$key";
            }
        }

        $placeholders_str = implode(", ", $placeholders);
        $sql = "INSERT INTO {$this->table} ($fields) VALUES ($placeholders_str)";

        return $this->DataBase->insert($sql, $data, false, true);
    }

    // Actualizar un registro
    public function update($data, $conditions)
    {
        $setParts = [];
        $params = [];

        foreach ($data as $key => $value) {
            if (preg_match('/\(\)$/', $value)) {
                // Si el valor es una función SQL (UUID(), NOW()), lo agrega directamente
                $setParts[] = "$key = $value";
            } else {
                $setParts[] = "$key = :$key";
                $params[$key] = $value;
            }
        }
        $setClause = implode(", ", $setParts);

        $whereParts = [];
        foreach ($conditions as $key => $value) {
            $whereParts[] = "$key = :where_$key";
            $params["where_$key"] = $value;
        }
        $whereClause = implode(" AND ", $whereParts);

        $sql = "UPDATE {$this->table} SET $setClause WHERE $whereClause";

        return $this->DataBase->update($sql, $params, false, true);
    }


    // Eliminar un registro
    public function delete($conditions)
    {
        $whereParts = [];
        foreach ($conditions as $key => $value) {
            $whereParts[] = "$key = :$key";
        }
        $whereClause = implode(" AND ", $whereParts);

        $sql = "DELETE FROM {$this->table} WHERE $whereClause";

        return $this->DataBase->update($sql, $conditions);
    }

    public function getToAttr($columna, $valor)
    {
        $this->filter($columna, '=', $valor);
        $filtro = $this->filterClauses();
        $params = [];

        if ($filtro) {
            $params = array_merge($params, $filtro[1]);
            $filtro = $filtro[0];
        }

        $sql = "SELECT * FROM {$this->table} $filtro";
        return $this->DataBase->fetchOne($sql, $params);
    }

    static public function generar_tabla($datos)
    {
        // Obtener encabezados únicos
        $encabezados = array_unique(array_keys(reset($datos)));

        // Construir la tabla con encabezados
        $tabla = '<table class="table" border="1"><tr>';
        foreach ($encabezados as $encabezado) {
            $tabla .= '<th>' . $encabezado . '</th>';
        }
        $tabla .= '</tr>';

        // Agregar filas con datos
        foreach ($datos as $registro) {
            $tabla .= '<tr>';
            foreach ($encabezados as $encabezado) {
                $valor = isset($registro[$encabezado]) ? $registro[$encabezado] : '';
                $tabla .= '<td>' . $valor . '</td>';
            }
            $tabla .= '</tr>';
        }

        $tabla .= '</table>';

        return $tabla;
    }
}
