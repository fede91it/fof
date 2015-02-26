<?php

class SpecialColumnsDataprovider
{
    public static function getTestReorder()
    {
        $data[] = array(
            array(
                'mock' => array(
                    'ordering' => array(1 => 1, 2 => 2, 3 => 3, 4 => 4)
                ),
                'where' => ''
            ),
            array(
                'case' => 'Records are have the same ordering as the id',
                'order' => array(1, 2, 3, 4, 5)
            )
        );

        $data[] = array(
            array(
                'mock' => array(
                    'ordering' => array(1 => 4, 2 => 3, 3 => 2, 4 => 1)
                ),
                'where' => ''
            ),
            array(
                'case' => 'Records in "reversed" order',
                'order' => array(4, 3, 2, 1, 5)
            )
        );

        $data[] = array(
            array(
                'mock' => array(
                    'ordering' => array(1 => 1, 2 => 3, 3 => 2, 4 => 1)
                ),
                'where' => ''
            ),
            array(
                'case' => 'Records with same order value',
                'order' => array(1, 4, 3, 2, 5)
            )
        );

        $data[] = array(
            array(
                'mock' => array(
                    'ordering' => array(1 => 0, 2 => 0, 3 => 0, 4 => 0)
                ),
                'where' => ''
            ),
            array(
                'case' => 'Records with no ordering',
                'order' => array(1, 3, 2, 4, 5)
            )
        );

        $data[] = array(
            array(
                'mock' => array(
                    'ordering' => array(1 => 0, 2 => 3, 3 => 8, 4 => 7)
                ),
                'where' => ''
            ),
            array(
                'case' => 'Records with non sequential order',
                'order' => array(1, 2, 5, 4, 3)
            )
        );

        $data[] = array(
            array(
                'mock' => array(
                    'ordering' => array(1 => 1, 2 => 2, 3 => 3, 4 => 4)
                ),
                'where' => 'foftest_foobar_id IN(2, 3)'
            ),
            array(
                'case' => 'Applying a reorder where',
                'order' => array(1, 1, 2, 4, 5)
            )
        );

        return $data;
    }

    public static function getTestMove()
    {
        $data[] = array(
            array(
                'mock' => array(
                    'find'     => null,
                    'delta'    => null,
                    'where'    => null
                ),
                'id'    => 1,
                'delta' => -1,
                'where' => ''
            ),
            array(
                'case' => 'Move the first record up, no where',
                'order' => array(1, 2, 3, 4, 5)
            )
        );

        $data[] = array(
            array(
                'mock' => array(
                    'find'     => null,
                    'delta'    => null,
                    'where'    => null
                ),
                'id'    => 1,
                'delta' => 0,
                'where' => ''
            ),
            array(
                'case' => 'Empty delta',
                'order' => array(1, 2, 3, 4, 5)
            )
        );

        $data[] = array(
            array(
                'mock' => array(
                    'find'     => null,
                    'delta'    => -1,
                    'where'    => null
                ),
                'id'    => 2,
                'delta' => '',
                'where' => ''
            ),
            array(
                'case' => 'Move the second record up, no where, delta changed by the event',
                'order' => array(2, 1, 3, 4, 5)
            )
        );

        $data[] = array(
            array(
                'mock' => array(
                    'find'     => null,
                    'delta'    => null,
                    'where'    => null
                ),
                'id'    => 2,
                'delta' => -1,
                'where' => ''
            ),
            array(
                'case' => 'Move the second record up, no where',
                'order' => array(2, 1, 3, 4, 5)
            )
        );

        $data[] = array(
            array(
                'mock' => array(
                    'find'     => null,
                    'delta'    => null,
                    'where'    => null
                ),
                'id'    => 2,
                'delta' => 1,
                'where' => ''
            ),
            array(
                'case' => 'Move the second record down, no where',
                'order' => array(1, 3, 2, 4, 5)
            )
        );

        $data[] = array(
            array(
                'mock' => array(
                    'find'     => null,
                    'delta'    => null,
                    'where'    => null
                ),
                'id'    => 2,
                'delta' => 1,
                'where' => 'title = "Guinea Pig row"'
            ),
            array(
                'case' => 'Move the second record down, with where matching nothing',
                'order' => array(1, 2, 3, 4, 5)
            )
        );

        $data[] = array(
            array(
                'mock' => array(
                    'find'     => null,
                    'delta'    => null,
                    'where'    => null
                ),
                'id'    => 2,
                'delta' => -1,
                'where' => 'title = "Guinea Pig row"'
            ),
            array(
                'case' => 'Move the second record up, with where matching one record',
                'order' => array(2, 1, 3, 4, 5)
            )
        );

        $data[] = array(
            array(
                'mock' => array(
                    'find'     => null,
                    'delta'    => 'title = "Guinea Pig row"',
                    'where'    => null
                ),
                'id'    => 2,
                'delta' => -1,
                'where' => ''
            ),
            array(
                'case' => 'Move the second record up, where matching one record (changed by the dispatcher)',
                'order' => array(2, 1, 3, 4, 5)
            )
        );

        $data[] = array(
            array(
                'mock' => array(
                    'find'     => 2,
                    'delta'    => null,
                    'where'    => null
                ),
                'id'    => null,
                'delta' => 1,
                'where' => ''
            ),
            array(
                'case' => 'Record loaded by the dispatcher, move the second record down, no where',
                'order' => array(1, 3, 2, 4, 5)
            )
        );

        return $data;
    }

    public static function getTestMoveException()
    {
        // Table with no ordering support
        $data[] = array(
            array(
                'tableid' => 'foftest_bare_id',
                'table' => '#__foftest_bares'
            ),
            array(
                'exception' => 'FOF30\Model\DataModel\Exception\SpecialColumnMissing'
            )
        );

        // Table with no ordering support
        $data[] = array(
            array(
                'tableid' => 'foftest_foobar_id',
                'table' => '#__foftest_foobars'
            ),
            array(
                'exception' => 'FOF30\Model\DataModel\Exception\RecordNotLoaded'
            )
        );

        return $data;
    }

    public static function getTestLock()
    {
        $data[] = array(
            array(
                'mock' => array(
                    'user_id' => ''
                ),
                'tableid' => 'foftest_bare_id',
                'table' => '#__foftest_bares',
                'user_id' => ''
            ),
            array(
                'case' => 'Table without locking support',
                'before' => 0,
                'after'  => 0,
                'dispatcher' => 0,
                'locked_by' => null,
                'locked_on' => null
            )
        );

        $data[] = array(
            array(
                'mock' => array(
                    'user_id' => ''
                ),
                'tableid' => 'foftest_foobar_id',
                'table' => '#__foftest_foobars',
                'user_id' => 90
            ),
            array(
                'case' => 'Table with locking support, user_id passed',
                'before' => 1,
                'after'  => 1,
                'dispatcher' => 2,
                'locked_by' => 90,
                'locked_on' => true
            )
        );

        $data[] = array(
            array(
                'mock' => array(
                    'user_id' => 88
                ),
                'tableid' => 'foftest_foobar_id',
                'table' => '#__foftest_foobars',
                'user_id' => null
            ),
            array(
                'case' => 'Table with locking support, user_id not passed',
                'before' => 1,
                'after'  => 1,
                'dispatcher' => 2,
                'locked_by' => 88,
                'locked_on' => true
            )
        );

        $data[] = array(
            array(
                'mock' => array(
                    'user_id' => ''
                ),
                'tableid' => 'id',
                'table' => '#__foftest_lockedby',
                'user_id' => 90
            ),
            array(
                'case' => 'Table with only the locked_by field',
                'before' => 1,
                'after'  => 1,
                'dispatcher' => 2,
                'locked_by' => 90,
                'locked_on' => null
            )
        );

        $data[] = array(
            array(
                'mock' => array(
                    'user_id' => ''
                ),
                'tableid' => 'id',
                'table' => '#__foftest_lockedon',
                'user_id' => 90
            ),
            array(
                'case' => 'Table with only the locked_on field',
                'before' => 1,
                'after'  => 1,
                'dispatcher' => 2,
                'locked_by' => null,
                'locked_on' => true
            )
        );

        return $data;
    }

    public static function getTestUnlock()
    {
        $data[] = array(
            array(
                'tableid' => 'foftest_bare_id',
                'table' => '#__foftest_bares',
            ),
            array(
                'case' => 'Table without locking support',
                'before' => 0,
                'after'  => 0,
                'dispatcher' => 0,
                'locked_by' => null,
                'locked_on' => null
            )
        );

        $data[] = array(
            array(
                'tableid' => 'foftest_foobar_id',
                'table' => '#__foftest_foobars',
            ),
            array(
                'case' => 'Table with locking support, user_id passed',
                'before' => 1,
                'after'  => 1,
                'dispatcher' => 2,
                'locked_by' => 0,
                'locked_on' => true
            )
        );

        $data[] = array(
            array(
                'tableid' => 'foftest_foobar_id',
                'table' => '#__foftest_foobars',
            ),
            array(
                'case' => 'Table with locking support, user_id not passed',
                'before' => 1,
                'after'  => 1,
                'dispatcher' => 2,
                'locked_by' => 0,
                'locked_on' => true
            )
        );

        $data[] = array(
            array(
                'tableid' => 'id',
                'table' => '#__foftest_lockedby',
            ),
            array(
                'case' => 'Table with only the locked_by field',
                'before' => 1,
                'after'  => 1,
                'dispatcher' => 2,
                'locked_by' => 0,
                'locked_on' => null
            )
        );

        $data[] = array(
            array(
                'tableid' => 'id',
                'table' => '#__foftest_lockedon',
            ),
            array(
                'case' => 'Table with only the locked_on field',
                'before' => 1,
                'after'  => 1,
                'dispatcher' => 2,
                'locked_by' => null,
                'locked_on' => true
            )
        );

        return $data;
    }

    public static function getTestTouch()
    {
        $data[] = array(
            array(
                'mock' => array(
                    'user_id' => ''
                ),
                'tableid' => 'foftest_bare_id',
                'table' => '#__foftest_bares',
                'user_id' => ''
            ),
            array(
                'case' => 'Table without modifying support',
                'modified_by' => null,
                'modified_on' => null
            )
        );

        $data[] = array(
            array(
                'mock' => array(
                    'user_id' => ''
                ),
                'tableid' => 'foftest_foobar_id',
                'table' => '#__foftest_foobars',
                'user_id' => 90
            ),
            array(
                'case' => 'Table with modifying support, user_id passed',
                'modified_by' => 90,
                'modified_on' => true
            )
        );

        $data[] = array(
            array(
                'mock' => array(
                    'user_id' => 88
                ),
                'tableid' => 'foftest_foobar_id',
                'table' => '#__foftest_foobars',
                'user_id' => null
            ),
            array(
                'case' => 'Table with modifying support, user_id not passed',
                'modified_by' => 88,
                'modified_on' => true
            )
        );

        $data[] = array(
            array(
                'mock' => array(
                    'user_id' => ''
                ),
                'tableid' => 'id',
                'table' => '#__foftest_modifiedby',
                'user_id' => 90
            ),
            array(
                'case' => 'Table with only the modified_by field',
                'modified_by' => 90,
                'modified_on' => null
            )
        );

        $data[] = array(
            array(
                'mock' => array(
                    'user_id' => ''
                ),
                'tableid' => 'id',
                'table' => '#__foftest_modifiedon',
                'user_id' => 90
            ),
            array(
                'case' => 'Table with only the modified_on field',
                'modified_by' => null,
                'modified_on' => true
            )
        );

        return $data;
    }
}